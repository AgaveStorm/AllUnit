<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template name="EditField">
        <xsl:param name="field"/>
        <xsl:param name="value"/>
        
        <div class="edit-field">
            <div class="label">
                <xsl:value-of select="$field/title"/>
            </div>
            <div class="value">
                <xsl:choose>
                    <xsl:when test="$field/type = 'text'">
                        <div class='textarea-container'>
                            <div class="add-media-button button"><i class="fa fa-image"/> &#160; Add media</div>
                            <textarea name="{$field/name}" class="tinymce"><xsl:value-of select="$value"/></textarea>
                        </div>
                    </xsl:when>

                    <xsl:when test="$field/type = 'img'">
                        <div class="img-field">
                            <input id="image" type="hidden" name="{$field/name}" value="{$value}"/>
                            <div class="img-container">
                                <xsl:if test="$value != ''">
                                    <img src="{//siteurl}/vhfiles?file={$value}&amp;w=100"/>
                                </xsl:if>
                            </div>
                        </div>
                    </xsl:when>
                    <xsl:when test="$field/type = 'id'">
                        <div class="id-field" 
                             data-list="{$field/list}" 
                             data-name="{$field/name}"
                             data-value="{$value}"/>
                    </xsl:when>
                    <xsl:when test="$field/type = ''">
                        <input type="text" name="{$field/name}" value="{$value}"
                            class="field-{$field/type}"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:apply-templates select="$field">
                            <xsl:with-param name="value" select="$value"/>
                        </xsl:apply-templates>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
